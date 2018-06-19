module Pages.Dashboard.View exposing(..)

import Html exposing(..)
import Html.Attributes exposing(..)
import Pages.Dashboard.Model exposing(..)
import Pages.Dashboard.Messages exposing(..)

view : Model -> Html Msg
view model =
    div [ class "col-md-12" ]
        [ div [ class "white-box" ]
            [ h3 [ class "box-title" ]
                [ text "Dashboard" ]
            ],
          div [class "sk-chasing-dots"]
            [div[class "sk-child sk-dot1"][], div[class "sk-child sk-dot2"][]]
        ]
