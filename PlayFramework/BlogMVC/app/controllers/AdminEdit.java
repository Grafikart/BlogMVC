package controllers;

import helpers.Secured;
import models.Posts;
import models.Users;
import play.db.jpa.Transactional;
import play.mvc.Controller;
import play.mvc.Result;
import play.mvc.Security;

/**
 * Created by greg on 17/09/2016.
 */

@Transactional
@Security.Authenticated(Secured.class)
public class AdminEdit extends Controller {

  public Result newPost() {
    return ok(views.html.admin_edit.render(new Posts(), Users.findAll()));
  }

  public Result editPost(Long postId) {
    Posts posts = Posts.find(postId);
    return ok(views.html.admin_edit.render(posts, Users.findAll()));
  }

  public Result savePost(Long postId) {
    return redirect(routes.Admin.index());
  }
}
