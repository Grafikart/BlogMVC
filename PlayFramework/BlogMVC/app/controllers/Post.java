package controllers;

import models.Categories;
import models.Comments;
import models.Posts;
import models.Users;
import play.Logger;
import play.data.Form;
import play.data.FormFactory;
import play.db.jpa.JPA;
import play.db.jpa.Transactional;
import play.mvc.Controller;
import play.mvc.Result;

import javax.inject.Inject;
import java.util.List;

/**
 * Created by grimaceplume on 17/09/2016.
 */

@Transactional
public class Post extends Controller {

  public Result postByAuthor(Integer pageNb, Long authorId) {
    Logger.info("Post.postByAuthor(pageNb: " + pageNb + ", authorId: " + authorId + ")");
    List<Posts> posts = Posts.findAllByAuthorFrom(Users.find(authorId), (pageNb - 1)  * 5, 5);
    if (posts == null) {
      //TODO add custom 404 page
      return notFound();
    }
    List<Posts> lastFivePost = Posts.findLastFivePost();
    List<Categories> allCategories = Categories.findAll();
    return ok(views.html.index.render(pageNb, posts.size() / 5 + 1, posts, lastFivePost, allCategories));
  }

  public Result postByCategory(Integer pageNb, Long categoryId) {
    Logger.info("Post.postByCategory(pageNb: " + pageNb + ", categoryId: " + categoryId + ")");

    List<Posts> posts = Posts.findAllByCategoriesFrom(Categories.find(categoryId), (pageNb - 1)  * 5, 5);
    if (posts == null) {
      //TODO add custom 404 page
      return notFound();
    }
    List<Posts> lastFivePost = Posts.findLastFivePost();
    List<Categories> allCategories = Categories.findAll();
    return ok(views.html.index.render(pageNb, posts.size() / 5 + 1, posts, lastFivePost, allCategories));
  }

  public Result post(Long id) {
    Logger.info("Post.post(id: " + id + ")");
    Posts post = Posts.find(id);
    if (post == null) {
      //TODO add custom 404 page
      return notFound();
    }
    List<Posts> lastFivePost = Posts.findLastFivePost();
    List<Categories> allCategories = Categories.findAll();
    return ok(views.html.post.render(post, lastFivePost, allCategories));
  }

  @Inject
  FormFactory formFactory;

  public Result addComment(Long postId) {
    Logger.info("Post.addComment(postId: " + postId + ")");
    Form<Comments.CommentForm> commentForm = formFactory.form(Comments.CommentForm.class).bindFromRequest();
    Posts post = Posts.find(postId);
    if (commentForm.hasErrors()) {
      flash("error", commentForm.globalErrors().toString());
      List<Posts> lastFivePost = Posts.findLastFivePost();
      List<Categories> allCategories = Categories.findAll();
      return badRequest(views.html.post.render(post, lastFivePost, allCategories));
    }
    Comments.CommentForm comment = commentForm.get();
    Comments comments = comment.toComment(post);
    Logger.info("Post.addComment(), new comment: " + comments);
    JPA.em().persist(comments);
    return post(postId);
  }
}
