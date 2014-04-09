namespace BlogMvc.Web.Models
{
    using System;
    using System.Collections.Generic;
    using System.ComponentModel.DataAnnotations;
    using System.ComponentModel.DataAnnotations.Schema;

    [Table("comments")]
    public partial class Comment
    {
        [Key]
        public int Id { get; set; }
        public int Post_Id { get; set; }

        [Required()]
        public string Username { get; set; }

        [Required()]
        [EmailAddress()]
        public string Mail { get; set; }


        [Required()]
        public string Content { get; set; }
        public System.DateTime Created { get; set; }


        [ForeignKey("Post_Id")]
        public virtual Post Post { get; set; }
    }
}
