using BlogMvc.Web.Models;
using BlogMvc.Web.ViewModels;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using System.Data.Entity;

namespace BlogMvc.Web.Controllers
{
    public class SideBarController : Controller
    {
        //
        // GET: /SideBar/
        [ChildActionOnly]
        public ActionResult Index()
        {

            HttpContext.Cache.Insert("Post", 1);
            Response.AddCacheItemDependency("Post");


            IList<Category> categories = new List<Category>();
            using (BlogMvcContext db = new BlogMvcContext())
            {
                categories = db.Categories
                    .Include(c => c.Posts)
                    .ToList();
            }


            IList<Post> posts = new List<Post>();
            using (BlogMvcContext db = new BlogMvcContext())
            {
                posts = db.Posts
                    .OrderByDescending(p => p.Created)
                    .Take(2)
                    .ToList();
            }

            return PartialView("_SideBar", new SideBarModel() { Categories = categories, Posts = posts });
        }

    }
}
