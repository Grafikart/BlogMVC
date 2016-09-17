package controllers;

import helpers.Secured;
import models.Posts;
import models.Users;
import play.Logger;
import play.data.DynamicForm;
import play.data.Form;
import play.db.jpa.Transactional;
import play.mvc.Controller;
import play.mvc.Result;
import play.mvc.Security;

import java.util.List;

/**
 * Created by greg on 16/09/2016.
 */

@Transactional
public class Admin extends Controller {

  @Security.Authenticated(Secured.class)
  public Result index(Integer pageNb) {
    Logger.info("Admin.index()");
    List<Posts> all = Posts.findFivePostFrom((pageNb - 1)  * 5);

    return ok(views.html.admin_index.render(pageNb, all.size() / 5 + 1, all));
  }

  public Result adminLogin() {
    Logger.info("Admin.adminLogin()");
    if (session().get("id").length() > 0) {
      redirect(routes.Admin.index(0));
    }
    return ok(views.html.login.render());
  }

  public Result adminPostLogin() {
    DynamicForm dynamicForm = Form.form().bindFromRequest();

    Logger.info("Admin.indexPostLogin(); formData: " + dynamicForm.data());

    String username = dynamicForm.get("username");
    String password = dynamicForm.get("password");
    Users user = Users.find(username);
    if (user == null || !password.equals(user.password)) {
      return badRequest(views.html.login.render());
    }

    session().clear();
    //TODO replace by token
    session("email", username);
    session("id", user.id.toString());
    return redirect(routes.Admin.index(1));
  }

  public Result adminLogout() {
    Logger.info("Admin.adminLogout()");

    session().clear();
    return redirect(routes.Index.index(1));
  }
}
