package controllers;

import helpers.Secured;
import play.mvc.Controller;
import play.mvc.Result;
import play.mvc.Security;

/**
 * Created by greg on 17/09/2016.
 */
@Security.Authenticated(Secured.class)
public class AdminEdit extends Controller {
  public Result editPost(Long postId) {
    return ok();
  }
}
