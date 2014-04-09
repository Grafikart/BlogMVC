using BlogMvc.Web.Models;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace BlogMvc.Web.ViewModels
{
    public class SideBarModel
    {
        public IEnumerable<Category> Categories { get; set; }
        public IEnumerable<Post> Posts { get; set; }

    }
}