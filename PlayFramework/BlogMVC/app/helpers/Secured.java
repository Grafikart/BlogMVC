package helpers;

/**
 * Created by greg on 16/09/2016.
 */

import play.mvc.Http.Context;
import play.mvc.Result;
import play.mvc.Security;

public class Secured extends Security.Authenticator {

  @Override
  public String getUsername(Context ctx) {
    return ctx.session().get("id");
  }

  @Override
  public Result onUnauthorized(Context ctx) {
    return redirect(controllers.routes.Admin.adminLogin());
  }
}