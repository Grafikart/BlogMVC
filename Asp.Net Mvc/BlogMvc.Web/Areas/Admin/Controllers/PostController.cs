using System;
using System.Collections.Generic;
using System.Data;
using System.Data.Entity;
using System.Linq;
using System.Net;
using System.Web;
using System.Web.Mvc;
using BlogMvc.Web.Models;
using EntityFramework.Batch;
using EntityFramework.Extensions;


namespace BlogMvc.Web.Areas.Admin.Controllers
{
    [Authorize]
    public class PostController : Controller
    {
        private BlogMvcContext db = new BlogMvcContext();
        public int ItemsByPage = 5;

        // GET: /Admin/Post/
        public ActionResult Index(int page = 1)
        {
            int startIndex = page <= 1
                ? 0
                : (page - 1) * this.ItemsByPage;

            var posts = db.Posts
                .Include(p => p.Category)
                .Include(p => p.User)
                .OrderByDescending(p => p.Created)
                .Skip(startIndex)
                .Take(this.ItemsByPage);

            return View(posts.ToList());
        }

        [ChildActionOnly]
        public ActionResult Pager()
        {
            int count = 0;
            int pages = 1;
            using (BlogMvcContext db = new BlogMvcContext())
            {
                count = db.Posts.Count();
            }
            pages = (count / this.ItemsByPage) + 1;

            return PartialView("~/Views/Shared/_Pager.cshtml", new BlogMvc.Web.ViewModels.PagerModel() { Count = count, Pages = pages });
        }

        // GET: /Admin/Post/Create
        public ActionResult Create()
        {
            ViewBag.Category_Id = new SelectList(db.Categories, "Id", "name");
            ViewBag.User_Id = new SelectList(db.Users, "Id", "Username");
            return View();
        }

        // POST: /Admin/Post/Create
        // Afin de déjouer les attaques par sur-validation, activez les propriétés spécifiques que vous voulez lier. Pour 
        // plus de détails, voir  http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Create([Bind(Include = "Id,Category_Id,User_Id,Name,Slug,Content")] Post post)
        {
            if (ModelState.IsValid)
            {
                post.Created = DateTime.Now;
                db.Posts.Add(post);
                db.SaveChanges();
                return RedirectToAction("Index");
            }

            ViewBag.Category_Id = new SelectList(db.Categories, "Id", "name", post.Category_Id);
            ViewBag.User_Id = new SelectList(db.Users, "Id", "Username", post.User_Id);

            // On invalide le cache de la sidebar
            HttpContext.Cache.Remove("Post");


            return View(post);
        }

        // GET: /Admin/Post/Edit/5
        public ActionResult Edit(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            Post post = db.Posts.Find(id);
            if (post == null)
            {
                return HttpNotFound();
            }
            ViewBag.Category_Id = new SelectList(db.Categories, "Id", "name", post.Category_Id);
            ViewBag.User_Id = new SelectList(db.Users, "Id", "Username", post.User_Id);
            return View(post);
        }

        // POST: /Admin/Post/Edit/5
        // Afin de déjouer les attaques par sur-validation, activez les propriétés spécifiques que vous voulez lier. Pour 
        // plus de détails, voir  http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Edit([Bind(Include = "Id,Category_Id,User_Id,Name,Slug,Content,Created")] Post post)
        {
            if (ModelState.IsValid)
            {
                db.Entry(post).State = System.Data.Entity.EntityState.Modified;
                db.SaveChanges();
                return RedirectToAction("Index");
            }
            ViewBag.Category_Id = new SelectList(db.Categories, "Id", "name", post.Category_Id);
            ViewBag.User_Id = new SelectList(db.Users, "Id", "Username", post.User_Id);


            // On invalide le cache de la sidebar
            HttpContext.Cache.Remove("Post");


            return View(post);
        }



        // POST: /Admin/Post/Delete/5
        public ActionResult Delete(int id)
        {
            Post post = db.Posts.Find(id);

            //next command seems to have problem with MySql
            //db.Comments.Delete(c => c.Post_Id == id);
            //So need to do it like good old ways !
            //You should not use it in production
            foreach (Comment comment in post.Comments.ToList())
                db.Comments.Remove(comment);
            db.SaveChanges();



            db.Posts.Remove(post);
            db.SaveChanges();



            // On invalide le cache de la sidebar
            HttpContext.Cache.Remove("Post");


            return RedirectToAction("Index");
        }

        protected override void Dispose(bool disposing)
        {
            if (disposing)
            {
                db.Dispose();
            }
            base.Dispose(disposing);
        }
    }
}
