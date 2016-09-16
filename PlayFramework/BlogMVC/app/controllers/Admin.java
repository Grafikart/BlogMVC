package controllers;

import helpers.Secured;
import models.Users;
import play.Logger;
import play.data.DynamicForm;
import play.data.Form;
import play.db.jpa.Transactional;
import play.mvc.Controller;
import play.mvc.Result;
import play.mvc.Security;

/**
 * Created by greg on 16/09/2016.
 */

@Transactional
public class Admin extends Controller {

  @Security.Authenticated(Secured.class)
  public Result index() {
    Logger.info("Admin.index()");
    return ok(views.html.admin_index.render());
  }

  public Result adminLogin() {
    Logger.info("Admin.adminLogin()");
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
    return redirect(routes.Admin.index());
  }

  public Result adminLogout() {
    Logger.info("Admin.adminLogout()");

    session().clear();
    return redirect(routes.Index.index(1));
  }
}
