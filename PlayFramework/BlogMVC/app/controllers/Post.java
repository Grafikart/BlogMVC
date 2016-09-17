package controllers;

import models.Posts;
import models.Users;
import play.db.jpa.Transactional;
import play.mvc.Controller;
import play.mvc.Result;

import java.util.List;

/**
 * Created by grimaceplume on 17/09/2016.
 */

@Transactional
public class Post extends Controller {

  //TODO Pagination
  public Result post(Long authorId) {
    List<Posts> posts = Posts.findAllByAuthor(Users.find(authorId));
    if (posts == null) {
      //TODO add custom 404 page
      return notFound();
    }
    return ok();
    //    return ok(views.html.post.render(posts));
  }

  public Result postByCategory(Long id) {
    return ok();
  }
}
