module Sidebar.Update exposing(..)

import Sidebar.Model exposing(..)
import Sidebar.Messages exposing(..)

type ParentMsg
    = NoEffect

update : Msg -> Model -> ( Model, Cmd Msg, ParentMsg)
update msg model =
    case msg of
        NoOp ->
            (model, Cmd.none, NoEffect)
