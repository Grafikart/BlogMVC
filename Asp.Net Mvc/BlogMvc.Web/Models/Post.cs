namespace BlogMvc.Web.Models
{
    using System;
    using System.Collections.Generic;
    using System.ComponentModel.DataAnnotations;
    using System.ComponentModel.DataAnnotations.Schema;

    [Table("posts")]
    public partial class Post
    {
        public Post()
        {
            this.Comments = new HashSet<Comment>();
        }
    
        [Key]
        public int Id { get; set; }
        public int Category_Id { get; set; }
        public int User_Id { get; set; }
        public string Name { get; set; }
        public string Slug { get; set; }
        public string Content { get; set; }
        public System.DateTime Created { get; set; }


        [InverseProperty("Post")]
        public virtual ICollection<Comment> Comments { get; set; }
        [ForeignKey("Category_Id")]
        public virtual Category Category { get; set; }
        [ForeignKey("User_Id")]
        public virtual User User { get; set; }
    }
}
