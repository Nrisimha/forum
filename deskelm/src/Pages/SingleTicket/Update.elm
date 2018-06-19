module Pages.SingleTicket.Update exposing (..)

import Pages.SingleTicket.Messages exposing (..)
import Pages.SingleTicket.Model exposing (..)


update : Msg -> Model -> ( Model, Cmd msg )
update msg model =
    case msg of
        NoOp ->
            ( model, Cmd.none )

        OnFetchTicket response ->
                ( { model | ticket = response }, Cmd.none )

        OnMessagesTab state ->
            ({model | messagesTab = state}, Cmd.none)
