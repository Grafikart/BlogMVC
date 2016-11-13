defmodule Blogmvc.UserController do

  use Blogmvc.Web, :controller
  alias Blogmvc.User

  def login(conn, _params) do
    conn = put_session(conn, :auth, %{id: 1})
    user = User.changeset(%User{})
    render conn, "login.html", user: user
  end

end