package controllers;

import play.mvc.Controller;
import play.mvc.Result;

/**
 * Created by greg on 16/09/2016.
 */
public class Index extends Controller {

  public Result index(Integer pageNb) {
    return ok(views.html.index.render());
  }

}
