package controllers;

import helpers.Secured;
import models.Categories;
import models.Posts;
import models.Slug;
import models.Users;
import org.joda.time.DateTime;
import play.Logger;
import play.data.DynamicForm;
import play.data.Form;
import play.db.jpa.JPA;
import play.db.jpa.Transactional;
import play.mvc.Controller;
import play.mvc.Result;
import play.mvc.Security;

import java.io.UnsupportedEncodingException;
import java.net.URLDecoder;
import java.net.URLEncoder;
import java.util.Objects;

/**
 * Created by grimaceplume on 17/09/2016.
 */

@Transactional
@Security.Authenticated(Secured.class)
public class AdminEdit extends Controller {

  public Result newPost() {
    return ok(views.html.admin_edit.render(new Posts(), Users.findAll(), Categories.findAll()));
  }

  public Result editPost(Long postId) {
    Posts posts = Posts.find(postId);
    return ok(views.html.admin_edit.render(posts, Users.findAll(), Categories.findAll()));
  }

  public Result savePost(Long postId) {
    DynamicForm dynamicForm = Form.form().bindFromRequest();
    String name = dynamicForm.get("name");
    String slug = dynamicForm.get("slug");
    String category_id = dynamicForm.get("category_id");
    String user_id = dynamicForm.get("user_id");
    String content = dynamicForm.get("content");

    Posts post;

    if (postId == 0) {
      post = new Posts();
    } else {
      post = Posts.find(postId);
      if (post == null) {
        post = new Posts();
        post.contents = content;
        post.name = name;
        flash("error", "This post id doesn't exist");
        return badRequest(views.html.admin_edit.render(post, Users.findAll(), Categories.findAll()));
      }
    }
    post.contents = content;
    post.name = name;
    if (post.name.length() == 0 || post.contents.length() == 0) {
      return badRequest(views.html.admin_edit.render(post, Users.findAll(), Categories.findAll()));
    }
    if (postId == 0)
      post.slug = new Slug();
    if (assignSlug(name, slug, post)) return internalServerError();
    post.slug.post = post;
    try {
      post.user = Users.find(Long.parseLong(user_id));
      post.categories = Categories.find(Long.parseLong(category_id));
    } catch (NumberFormatException e) {
      Logger.error(e.getMessage());
      return internalServerError();
    }
    post.created = DateTime.now();
    JPA.em().persist(post);
    return redirect(routes.Admin.index(1));
  }

  private boolean assignSlug(String name, String slug, Posts post) {
    try {
      String decode = URLDecoder.decode(slug, "UTF-8");
      if (Objects.equals(decode, name)) {
        return false;
      }
    } catch (UnsupportedEncodingException ignored) {
    }
    try {
      post.slug.name = URLEncoder.encode(slug.length() > 0 ? slug : name, "UTF-8");
      while (post.id == null && Slug.find(post.slug.name) != null) {
        post.slug.name += "_new";
      }
    } catch (UnsupportedEncodingException e) {
      Logger.error(e.getMessage());
      return true;
    }
    return false;
  }
}
