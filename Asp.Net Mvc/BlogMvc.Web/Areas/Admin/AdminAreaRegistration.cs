using System.Web.Mvc;

namespace BlogMvc.Web.Areas.Admin
{
    public class AdminAreaRegistration : AreaRegistration 
    {
        public override string AreaName 
        {
            get 
            {
                return "Admin";
            }
        }

        public override void RegisterArea(AreaRegistrationContext context) 
        {
            context.MapRoute(
                "Admin_default",
                "Admin/{controller}/{action}/{id}",
                new { controller = "Post", action = "Index", id = UrlParameter.Optional },
                namespaces: new [] { "BlogMvc.Web.Areas.Admin.Controllers" }
            );
        }
    }
}