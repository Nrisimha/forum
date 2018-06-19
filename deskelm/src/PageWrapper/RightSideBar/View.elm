module PageWrapper.RightSideBar.View exposing (..)

import Html exposing (..)
import Html.Attributes exposing (alt, class, href, src)
import PageWrapper.RightSideBar.Messages exposing (..)
import PageWrapper.RightSideBar.Model exposing (..)


view : Model -> Html msg
view model =
    div [ class "right-sidebar" ]
        [ div [ class "slimscrollright" ]
            [ div [ class "rpanel-title" ]
                [ text "Service Panel"
                , span
                    []
                    [ i [ class "ti-close right-side-toggle" ]
                        []
                    ]
                ]
            , div [ class "r-panel-body" ]
                [ ul [ class "m-t-20 chatonline" ]
                    (List.map chatUser model.users)
                ]
            ]
        ]


chatUser : User -> Html msg
chatUser {statusClass, name, photo, status} =
    li []
    [a [ href "javascript:void(0)" ]
        [ img [ src photo, alt "user-img", class "img-circle" ]
            []
        , span []
            [ text name
            , small
                [ class statusClass ]
                [ text status ]
            ]
        ]
        ]
