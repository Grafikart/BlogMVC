package controllers;

import models.Categories;
import models.Posts;
import models.Slug;
import play.Logger;
import play.db.jpa.Transactional;
import play.mvc.Controller;
import play.mvc.Result;

import java.util.List;

/**
 * Created by greg on 17/09/2016.
 */

@Transactional
public class Slugs extends Controller {
  public Result slug(String slugName) {
    Logger.info("Slugs.slug(slugName: " + slugName + ")");
    Slug slug = Slug.find(slugName);
    if (slug == null) {
      Logger.error("Slugs.slug notFound");
      return notFound();
    }
    if (slug.categorie != null) {
      return redirect(routes.Post.postByCategory(1, slug.categorie.id));
    }
    List<Posts> lastFivePost = Posts.findLastFivePost();
    List<Categories> allCategories = Categories.findAll();
    return ok(views.html.post.render(slug.post, lastFivePost, allCategories));
  }
}
