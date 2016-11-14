defmodule Blogmvc.GravatarHelpers do

  def gravatar(email) do
    "http://1.gravatar.com/avatar/" <> md5(email) <> "?s=200&r=pg&d=mm"
  end

  defp md5(s) do
    Base.encode16(:erlang.md5(s), case: :lower)
  end

end