using System;
using System.Data.Entity;
using System.Data.Entity.Infrastructure;
using System.Threading;
using System.Web.Mvc;
using WebMatrix.WebData;
using BlogMvc.Web.Models;
using System.Linq;
using System.Web.Security;
using System.Text;
using System.Security.Cryptography;

namespace BlogMvc.Web.Filters
{
    public class CustomAdminMembershipProvider : SimpleMembershipProvider
    {

        public CustomAdminMembershipProvider()
        {
        }

        public override bool ValidateUser(string username, string password)
        {
            if (string.IsNullOrEmpty(username))
            {
                throw new ArgumentException("Argument cannot be null or empty", "username");
            }

            if (string.IsNullOrEmpty(password))
            {
                throw new ArgumentException("Argument cannot be null or empty", "password");
            }


            using (BlogMvcContext db = new BlogMvcContext())
            {
                User user = db.Users.Where(u => u.Username == username).FirstOrDefault();


                if (user == null)
                {
                    return false;
                }


                HashAlgorithm hash = null;
                hash = System.Security.Cryptography.SHA1.Create();
                //Valeurs possibles => shA1, md5, KeyedHashAlgorithm, RIPEMD160

                byte[] passBits = hash.ComputeHash(Encoding.UTF8.GetBytes(password));
                string hashedPassword = BitConverter.ToString(passBits).Replace("-","").ToLower();
                //string hashedPassword = Encoding.UTF8.GetString(passBits);



                return user.Password == hashedPassword;
            }
        }
    }
}