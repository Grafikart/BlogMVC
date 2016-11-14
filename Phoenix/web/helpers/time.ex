defmodule Blogmvc.TimeHelpers do

  use Timex
  alias Ecto.DateTime

  def from_now(datetime) do
    date = datetime
      |> DateTime.to_erl
      |> :calendar.datetime_to_gregorian_seconds
      |> Kernel.-(62167219200)
      |> Timex.from_unix
      |> Timex.from_now
  end

end