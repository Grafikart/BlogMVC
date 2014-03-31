using System;
using System.Data.Entity;
using System.Data.Entity.Infrastructure;
using System.Threading;
using System.Web.Mvc;
using WebMatrix.WebData;
using BlogMvc.Web.Models;

namespace BlogMvc.Web.Filters
{
    [AttributeUsage(AttributeTargets.Class | AttributeTargets.Method, AllowMultiple = false, Inherited = true)]
    public sealed class InitializeSimpleMembershipAttribute : ActionFilterAttribute
    {
        private static SimpleMembershipInitializer _initializer;
        private static object _initializerLock = new object();
        private static bool _isInitialized;

        public override void OnActionExecuting(ActionExecutingContext filterContext)
        {
            // S'assurer qu'ASP.NET Simple Membership est initialisé une seule fois par démarrage d'application
            LazyInitializer.EnsureInitialized(ref _initializer, ref _isInitialized, ref _initializerLock);
        }

        private class SimpleMembershipInitializer
        {

            public SimpleMembershipInitializer()
            {
                Database.SetInitializer<BlogMvcContext>(null);
                //WebSecurity.InitializeDatabaseConnection("BlogMvcContext", "MySql.Data.MySqlClient", "users", "id", "username", autoCreateTables: false);
            }

            //public SimpleMembershipInitializer()
            //{
            //    Database.SetInitializer<UsersContext>(null);

            //    try
            //    {
            //        using (var context = new UsersContext())
            //        {
            //            if (!context.Database.Exists())
            //            {
            //                // Créer la base de données SimpleMembership sans schéma de migration Entity Framework
            //                ((IObjectContextAdapter)context).ObjectContext.CreateDatabase();
            //            }
            //        }

            //        WebSecurity.InitializeDatabaseConnection("DefaultConnection", "UserProfile", "UserId", "UserName", autoCreateTables: true);
            //    }
            //    catch (Exception ex)
            //    {
            //        throw new InvalidOperationException("Impossible d'initialiser la base de données ASP.NET Simple Membership. Pour plus d'informations, consultez la page http://go.microsoft.com/fwlink/?LinkId=256588", ex);
            //    }
            //}
        }
    }
}
