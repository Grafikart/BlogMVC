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
      return notFound();
    }
    //TODO add, categories slug support
    return ok(views.html.post.render(slug.post));
  }
}
