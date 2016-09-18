package controllers;

import models.Categories;
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

  public Result postByAuthor(Integer pageNb, Long authorId) {
    List<Posts> posts = Posts.findAllByAuthorFrom(Users.find(authorId), (pageNb - 1)  * 5, 5);
    if (posts == null) {
      //TODO add custom 404 page
      return notFound();
    }
//    return ok();
    return ok(views.html.index.render(pageNb, posts.size() / 5 + 1, posts));
  }

  public Result postByCategory(Integer pageNb, Long categoryId) {
    List<Posts> posts = Posts.findAllByCategoriesFrom(Categories.find(categoryId), (pageNb - 1)  * 5, 5);
    if (posts == null) {
      //TODO add custom 404 page
      return notFound();
    }
//    return ok();
    return ok(views.html.index.render(pageNb, posts.size() / 5 + 1, posts));
  }
}
