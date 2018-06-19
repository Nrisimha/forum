module Pages.Dashboard.Update exposing(..)

import Pages.Dashboard.Messages exposing (..)
import Pages.Dashboard.Model exposing (..)


update : Msg -> Model -> ( Model, Cmd msg )
update msg model =
    case msg of
        NoOp ->
            ( model, Cmd.none )