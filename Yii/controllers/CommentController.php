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
     * @throws \EHttpException HTTP error 400 is raised if specified post
     * hasn't been found.
     * @throws \EHttpException HTTP error 400 is raised if no data hasn't been
     * received.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionAdd($postSlug)
    {
        $post = \Post::model()->find('slug = :slug', array(':slug' => $postSlug));
        $data = \Yii::app()->request->getPost('Comment', false);
        if (!$post) {
            throw new \EHttpException(400, 'badRequest.postNotFound');
        } else if (!$data) {
            throw new \EHttpException(400, 'badRequest.noDataReceived');
        }
        $comment = new Comment;
        $comment->post_id = $post->getPrimaryKey();
        if ($comment->setAndSave($data)) {
            \Yii::app()->user->sendSuccessMessage('comment.submit.success');
        } else {
            \Yii::app()->user->sendErrorMessage('comment.submit.fail');
            \Yii::app()->user->saveData('comment', $data);
        }
        $redirect = array(
            'post/show',
            'slug' => $post->slug,
            '#' => 'comment-form',
        );
        $this->redirect($redirect);
    }

    /**
     * Adds comment via ajax.
     *
     * @param string $postSlug Parent post slug.
     *
     * @throws \EHttpException HTTP error 400 is thrown if non-ajax request is
     *                         received, there is no post with provided slug or
     *                         no data has been posted.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionAjaxAdd($postSlug)
    {
        if (\Yii::app()->request->isAjaxRequest
            && (!defined('YII_DEBUG') || !YII_DEBUG)
        ) {
            throw new \EHttpException(400, 'badRequest.ajaxOnly');
        }
        $post = \Post::model()->find('slug = :slug', array(':slug' => $postSlug));
        $data = \Yii::app()->request->getPost('Comment', false);
        if (!$post) {
            throw new \EHttpException(400, 'badRequest.postNotFound');
        } else if (!$data) {
            throw new \EHttpException(400, 'badRequest.noDataReceived');
        }
        $comment = new Comment;
        $comment->post_id = $post->getPrimaryKey();
        $response = array('success' => true,);
        if (!$comment->setAndSave($data)) {
            $response['success'] = false;
            $response['errors'] = $comment->getErrors();
        }
        echo \CJSON::encode($response);
    }

    /**
     * Deletes comment specified by <var>$id</var>.
     *
     * @param int $id ID of the comment to be deleted.
     * 
     * @throws \EHttpException HTTP error 400 is generated if specified comment
     * hasn't been found.
     * @throws \EHttpException HTTP error 500 is generated if parent post for
     * specified comment hasn't been found (since it points to data integrity
     * failure).
     * @throws \EHttpException HTTP error 403 is generated if comment's parent
     * post doesn't belong to current user.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionDelete($id)
    {
        $comment = \Comment::model()->with('post')->findByPk($id);
        if ($comment === null) {
            throw new \EHttpException(400, 'badRequest.commentNotFound');
        } else if ($comment->post === null) {
            $message = 'Data integrity failure: comment#'.$id. ' doesn\'t '.
                'have parent post';
            \Yii::log($message, CLogger::LEVEL_ERROR );
            throw new \EHttpException(
                500,
                'internalServerError.dataIntegrityFailure'
            );
        } else if ((int) $comment->post->user_id !== \Yii::app()->user->id) {
            throw new \EHttpException(403, 'notAuthorized.postOwnership');
        }
        $comment->delete();
        \Yii::app()->user->sendNotice('comment.delete');
        $this->redirect(array('post/show', 'slug' => $comment->post->slug));
    }
}
