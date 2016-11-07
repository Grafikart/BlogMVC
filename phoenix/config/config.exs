# This file is responsible for configuring your application
# and its dependencies with the aid of the Mix.Config module.
#
# This configuration file is loaded before any dependency and
# is restricted to this project.
use Mix.Config

# General application configuration
config :blogmvc,
  ecto_repos: [Blogmvc.Repo]

# Configures the endpoint
config :blogmvc, Blogmvc.Endpoint,
  url: [host: "localhost"],
  secret_key_base: "TKMUea3fkkQNsqzNqaErAMnP4EDUAwpGZGcLIpjHcudQzkEIlASuud4lxK9b0qEJ",
  render_errors: [view: Blogmvc.ErrorView, accepts: ~w(html json)],
  pubsub: [name: Blogmvc.PubSub,
           adapter: Phoenix.PubSub.PG2]

# Configures Elixir's Logger
config :logger, :console,
  format: "$time $metadata[$level] $message\n",
  metadata: [:request_id]

# Pagination HTML
config :scrivener_html,
  routes_helper: Blogmvc.Router.Helpers

# Import environment specific config. This must remain at the bottom
# of this file so it overrides the configuration defined above.
import_config "#{Mix.env}.exs"
