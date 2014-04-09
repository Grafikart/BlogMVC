namespace BlogMvc.Web.Models
{
    using System;
    using System.Collections.Generic;
    using System.ComponentModel.DataAnnotations;
    using System.ComponentModel.DataAnnotations.Schema;


    [Table("users")] 
    public partial class User
    {
        public User()
        {
            this.Posts = new HashSet<Post>();
        }
    
        [Key]
        public int Id { get; set; }
        public string Username { get; set; }
        public string Password { get; set; }

        [InverseProperty("User")]
        public virtual ICollection<Post> Posts { get; set; }
    }
}
