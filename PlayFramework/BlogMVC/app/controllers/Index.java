package controllers;

import models.Posts;
import play.Logger;
import play.db.jpa.Transactional;
import play.mvc.Controller;
import play.mvc.Result;

import java.util.List;

/**
 * Created by greg on 16/09/2016.
 */

@Transactional
public class Index extends Controller {

  public Result index(Integer pageNb) {
    Logger.info("Index.index(pageNb: " + pageNb + ");" );

    List<Posts> all = Posts.findFivePostFrom((pageNb - 1)  * 5);
    return ok(views.html.index.render(pageNb, all.size() / 5 + 1));
  }
}

