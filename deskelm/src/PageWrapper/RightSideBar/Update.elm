module PageWrapper.RightSideBar.Update exposing(..)

import PageWrapper.RightSideBar.Model exposing(..)
import PageWrapper.RightSideBar.Messages exposing(..)

update : Msg -> Model -> (Model, Cmd msg)
update msg model =
    case msg of
        NoOp ->
            (model, Cmd.none)