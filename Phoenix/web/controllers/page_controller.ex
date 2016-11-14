defmodule Blogmvc.PageController do
  use Blogmvc.Web, :controller

  def index(conn, _params) do
    render conn, "index.html"
  end
end
