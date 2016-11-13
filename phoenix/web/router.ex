defmodule Blogmvc.Router do
  use Blogmvc.Web, :router

  pipeline :browser do
    plug :accepts, ["html"]
    plug :fetch_session
    plug :fetch_flash
    plug :protect_from_forgery
    plug :put_secure_browser_headers
  end

  pipeline :auth do
    plug Blogmvc.Plugs.Auth
  end

  pipeline :api do
    plug :accepts, ["json"]
  end

  scope "/", Blogmvc do
    pipe_through :browser # Use the default browser stack

    get "/", PostController, :index
    get "/login", UserController, :login
    get "/articles/:slug", PostController, :show
    get "/category/:slug", PostController, :category

    resources "/posts", PostController, only: [] do
      resources "/comments", CommentController, only: [:create]
    end
  end

  scope "/admin" do
    pipe_through :browser
    pipe_through :auth

    resources "/posts", Blogmvc.Admin.PostController
  end

  # Other scopes may use custom stacks.
  # scope "/api", Blogmvc do
  #   pipe_through :api
  # end
end
