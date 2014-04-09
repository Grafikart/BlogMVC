using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using System.Web.Routing;

namespace BlogMvc.Web
{
    public class RouteConfig
    {
        public static void RegisterRoutes(RouteCollection routes)
        {
            routes.IgnoreRoute("{resource}.axd/{*pathInfo}");


            //GET: Login
            routes.MapRoute(
                name: "Login",
                url: "Account/{Action}",
                defaults: new { controller = "Account", action = "Login" },
                namespaces: new String[] { "BlogMvc.Web.Controllers" }
            );


            //GET: /{slug} Single
            routes.MapRoute(
                name: "Slug",
                url: "{slug}",
                defaults: new { controller = "Post", action = "Details" },
                constraints: new { httpMethod = new HttpMethodConstraint("GET") },
                namespaces: new String[] { "BlogMvc.Web.Controllers"}
            );


            //GET: / The homepage with blog posts
            //GET: /category/{slug} Posts from a category
            //GET: /author/{id} Posts from an author
            //GET: /....?page=2 Pagination using query parameters
            routes.MapRoute(
                name: "Default_",
                url: "{controller}/{id}",
                defaults: new { controller = "Post", action = "Index"},
                constraints: new { httpMethod = new HttpMethodConstraint("GET") },
                namespaces: new String[] { "BlogMvc.Web.Controllers" }
            );


            //GET: / For other actions
            //GET: /admin Backend entry point
            routes.MapRoute(
                name: "Default",
                url: "{controller}/{action}/{id}",
                defaults: new { controller = "Post", action = "Index", id = UrlParameter.Optional },
                namespaces: new String[] { "BlogMvc.Web.Controllers" }
            );


            //Routes admin
            //Cf Areas directory
        }
    }
}