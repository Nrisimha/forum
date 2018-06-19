module Navbar.Update exposing (..)

import Navbar.Messages exposing (..)
import Navbar.Model exposing(Model)

type ParentMsg
    = SearchText String
    | NoEffect

update : Msg -> Model -> ( Model, Cmd Msg, ParentMsg )
update msg model =
    case msg of
        OnSearch ->
            ( model, Cmd.none, SearchText model.searchTxt)

        UpdateSearchText txt ->
            ( { model | searchTxt = txt }, Cmd.none, NoEffect )

        ToggleNotificationPanel ->
            let
                classes =
                    if String.length model.notificationPanelClasses == 0 then
                        "show open"
                    else
                        ""
            in
            ( { model
                | notificationPanelClasses = classes
                , taskPanelClasses = ""
                , userPanelClasses = ""
              }
            , Cmd.none
            , NoEffect
            )

        ToggleTaskPanel ->
            let
                classes =
                    if String.length model.taskPanelClasses == 0 then
                        "show open"
                    else
                        ""
            in
                ( { model
                    | taskPanelClasses = classes
                    , notificationPanelClasses = ""
                    , userPanelClasses = ""
                  }
                , Cmd.none
                , NoEffect
                )

        ToggleUserPanel ->
            let
                classes =
                    if String.length model.userPanelClasses == 0 then
                        "show open"
                    else
                        ""
            in
            ( { model
                | userPanelClasses = classes
                , taskPanelClasses = ""
                , notificationPanelClasses = ""
              }
            , Cmd.none
            , NoEffect
            )

