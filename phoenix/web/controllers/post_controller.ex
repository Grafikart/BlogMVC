defmodule Blogmvc.PostController do

  use Blogmvc.Web, :controller
  alias Blogmvc.Post

  def index(conn, params) do
    posts = Post
      |> preload([:user, :category])
      |> Repo.paginate(Map.put(params, :page_size, 2))
    render conn, "index.html", posts: posts
  end

end
