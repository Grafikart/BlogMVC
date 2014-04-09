using BlogMvc.Web.Models;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using System.Data.Entity;
using BlogMvc.Web.ViewModels;

namespace BlogMvc.Web.Controllers
{
    public class CategoryController : Controller
    {
        //
        // GET: /Category/

        public int ItemsByPage = 5;

        [OutputCache(Duration = 3600, VaryByParam = "*", Location = System.Web.UI.OutputCacheLocation.Server)]
        public ActionResult Index(string id, int page = 1)
        {
            //On charge l'ensemble des posts de la catégorie
            IList<Post> posts = new List<Post>();
            using (BlogMvcContext db = new BlogMvcContext())
            {
                int startIndex = page <= 1
                    ? 0
                    : (page - 1) * this.ItemsByPage;

                posts = db.Posts
                    .Where(p => p.Category.slug == id)
                    .Include(p => p.Category)
                    .Include(p => p.User)
                    .OrderByDescending(p => p.Created)
                    .Skip(startIndex)
                    .Take(this.ItemsByPage)
                    .ToList();
            }


            ViewBag.Slug = id;


            //Mise en place d'une dépendance sur le cache
            if (HttpContext.Cache["Post"] == null)
                HttpContext.Cache["Post"] = DateTime.UtcNow.ToString();
            Response.AddCacheItemDependency("Post");


            return View(posts);
        }

        [ChildActionOnly]
        public ActionResult Pager(string id)
        {
            int count = 0;
            int pages = 1;
            using (BlogMvcContext db = new BlogMvcContext())
            {
                count = db.Posts
                    .Where(p => p.Category.slug == id)
                    .Count();
            }
            pages = (count / this.ItemsByPage) + 1;

            return PartialView("~/Views/Shared/_Pager.cshtml", new PagerModel() { Count = count, Pages = pages });
        }

    }
}
