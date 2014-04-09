using System;
using System.Collections.Generic;
using System.Linq;
using System.Web.Http;

namespace BlogMvc.Web
{
    public static class WebApiConfig
    {
        public static void Register(HttpConfiguration config)
        {
            config.Routes.MapHttpRoute(
                name: "DefaultApi",
                routeTemplate: "api/{controller}/{id}",
                defaults: new { id = RouteParameter.Optional }
            );

            // Supprimez les commentaires de la ligne de code suivante pour activer la prise en charge des requêtes pour les actions ayant un type de retour IQueryable ou IQueryable<T>.
            // Pour éviter le traitement de requêtes inattendues ou malveillantes, utilisez les paramètres de validation définis sur QueryableAttribute pour valider les requêtes entrantes.
            // Pour plus d’informations, visitez http://go.microsoft.com/fwlink/?LinkId=279712.
            //config.EnableQuerySupport();
        }
    }
}