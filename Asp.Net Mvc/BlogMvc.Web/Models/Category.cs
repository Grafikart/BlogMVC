namespace BlogMvc.Web.Models
{
    using System;
    using System.Collections.Generic;
    using System.ComponentModel.DataAnnotations;
    using System.ComponentModel.DataAnnotations.Schema;

    [Table("categories")]
    public partial class Category
    {
        public Category()
        {
            this.Posts = new HashSet<Post>();
        }
    
        [Key]
        public int Id { get; set; }
        public string name { get; set; }
        public string slug { get; set; }
        public string post_count { get; set; }
    
        public virtual ICollection<Post> Posts { get; set; }
    }
}
