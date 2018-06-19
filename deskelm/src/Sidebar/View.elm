module Sidebar.View exposing (..)

import Html exposing (..)
import Html.Attributes exposing (..)
import Models
import RemoteData
import Sidebar.Menu exposing (renderLinks)


view { model, user } =
    div [ class "navbar-default sidebar" ]
        [ div [ class "sidebar-nav navbar-collapse slimscrollsidebar" ]
            [ ul [ class "nav", id "side-menu" ]
                (List.append
                    [ li [ class "sidebar-search hidden-sm hidden-md hidden-lg" ]
                        [ div [ class "input-group custom-search-form" ]
                            [ input [ type_ "text", class "form-control", placeholder "Search..." ]
                                []
                            , span [ class "input-group-btn" ]
                                [ button [ class "btn btn-default", type_ "button" ]
                                    [ i [ class "fa fa-search" ]
                                        []
                                    ]
                                ]
                            ]
                        ]
                    , li [ class "user-pro" ]
                        [ (mayBeUser user)
                        , ul [ class "nav nav-second-level" ]
                            [ li []
                                [ a [ href "javascript:void(0)" ]
                                    [ i [ class "ti-user" ]
                                        []
                                    , text "My Profile"
                                    ]
                                ]
                            , li []
                                [ a [ href "javascript:void(0)" ]
                                    [ i [ class "ti-email" ]
                                        []
                                    , text "Inbox"
                                    ]
                                ]
                            , li []
                                [ a [ href "javascript:void(0)" ]
                                    [ i [ class "ti-settings" ]
                                        []
                                    , text "Account Setting"
                                    ]
                                ]
                            , li []
                                [ a [ href "javascript:void(0)" ]
                                    [ i [ class "fa fa-power-off" ]
                                        []
                                    , text "Logout"
                                    ]
                                ]
                            ]
                        ]
                    , li [ class "nav-small-cap m-t-10" ]
                        [ text "--- Main Menu" ]
                    ]
                    (renderLinks model)
                )
            ]
        ]


spinner : Html msg
spinner =
    a [ href "#", class "waves-effect active" ][
    div [ class "sk-wave sk-inline" ]
        [ div [ class "sk-rect sk-rect1" ]
            []
        , div [ class "sk-rect sk-rect2" ]
            []
        , div [ class "sk-rect sk-rect3" ]
            []
        , div [ class "sk-rect sk-rect4" ]
            []
        , div [ class "sk-rect sk-rect5" ]
            []
        ]]


renderUser : Models.User -> Html msg
renderUser {name} =
    a [ href "#", class "waves-effect active" ]
        [ img [ src "../plugins/images/users/varun.jpg", alt "user-img", class "img-circle" ]
            []
        , span [ class "hide-menu" ]
            [ text name
            , span [ class "fa arrow" ]
                []
            ]
        ]


mayBeUser response =
    case response of
        RemoteData.NotAsked ->
            spinner

        RemoteData.Loading ->
            spinner

        RemoteData.Success user ->
            renderUser user

        RemoteData.Failure e ->
            spinner
