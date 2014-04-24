<?php

/**
 * This controller handles all the logic related to comments.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class CommentController extends \BaseController
{
    /**
     * Action for adding new comment to post.
     *
     * @param string $postSlug Slug of the post comment should be added to.
     * 
     * @throws \HttpException HTTP error 400 is raised if specified post
     * hasn't been found.
     * @throws \HttpException HTTP error 400 is raised if no data hasn't been
     * received.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionAdd($postSlug)
    {
        $post = \Post::model()->find('slug = :slug', array(':slug' => $postSlug));
        $data = \Yii::app()->request->getPost('Comment', false);
        if ($post === null) {
            throw new \HttpException(400, 'badRequest.postNotFound');
        } else if ($data === false) {
            throw new \HttpException(400, 'badRequest.noDataReceived');
        }
        $comment = new Comment;
        $comment->post_id = $post->getPrimaryKey();
        if ($comment->setAndSave($data)) {
            \Yii::app()->user->sendMessage(
                'comment.submit.success',
                WebUserLayer::FLASH_SUCCESS
            );
        } else {
            \Yii::app()->user->sendMessage(
                'comment.submit.fail',
                WebUserLayer::FLASH_ERROR
            );
            \Yii::app()->user->saveData('comment', $data);
        }
        $this->redirect(
            array(
                'post/show',
                'slug' => $post->slug,
                '#' => 'comment-form',
            )
        );
    }
    /**
     * Deletes comment specified by <var>$id</var>.
     *
     * @param int $id ID of the comment to be deleted.
     * 
     * @throws \HttpException HTTP error 400 is generated if specified comment
     * hasn't been found.
     * @throws \HttpException HTTP error 500 is generated if parent post for
     * specified comment hasn't been found (since it points to data integrity
     * failure).
     * @throws \HttpException HTTP error 403 is generated if comment's parent
     * post doesn't belong to current user.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionDelete($id)
    {
        $comment = \Comment::model()->with('post')->findByPk($id);
        if ($comment === null) {
            throw new \HttpException(400, 'badRequest.commentNotFound');
        } else if ($comment->post === null) {
            Yii::log(
                'Data integrity failure: comment#'.$id.' doesn\'t have parent post',
                CLogger::LEVEL_ERROR
            );
            throw new \HttpException(500, 'internalServerError.dataIntegrityFailure');
        } else if ((int)$comment->post->user_id !== Yii::app()->user->id) {
            throw new \HttpException(403, 'notAuthorized.postOwnership');
        }
        $comment->delete();
        \Yii::app()->user->sendMessage('comment.delete');
        $this->redirect(array('post/show', 'slug' => $comment->post->slug));
    }
}
