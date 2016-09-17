package controllers;

import play.db.jpa.Transactional;
import play.mvc.Controller;
import play.mvc.Result;

/**
 * Created by greg on 17/09/2016.
 */

@Transactional
public class Slugs extends Controller {
  public Result slug(String slugName) {
    return ok();
  }
}
