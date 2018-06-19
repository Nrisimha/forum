module Pages.Tickets.Update exposing (..)

import Pages.Tickets.Messages exposing (..)
import Pages.Tickets.Model exposing (..)


update : Msg -> Model -> ( Model, Cmd msg )
update msg model =
    case msg of
        NoOp ->
            ( model, Cmd.none )

        OnFetchTickets response ->
                ( { model | tickets = response }, Cmd.none )
