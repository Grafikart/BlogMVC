package controllers;

import models.Slug;
import play.Logger;
import play.db.jpa.Transactional;
import play.mvc.Controller;
import play.mvc.Result;

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
      //TODO add custom 404 page
      return notFound();
    }
    if (slug.categorie != null) {
      return redirect(routes.Post.postByCategory(1, slug.categorie.id));
    }
    return redirect(routes.Post.post(slug.post.id));
  }
}
