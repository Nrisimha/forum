module Main exposing (..)

import Html exposing (..)
import Html.Attributes exposing (class, href, id)
import Messages exposing (..)
import Models exposing (..)
import Navbar.View as NavBar
import Navigation exposing (Location)
import PageWrapper.View as PageWrapper
import Routing
import Sidebar.View as SideBar
import Update exposing (..)
import Commands exposing(getUser)
import RouteCommands


init : Location -> ( Model, Cmd Msg )
init location =
    let
        currentRoute =
            Routing.parseLocation location
    in
    ( model currentRoute, Cmd.batch [getUser, RouteCommands.getOnInitCommand currentRoute] )


view : Model -> Html Msg
view model =
    div [ id "wrapper" ]
        (getView model)


subscriptions : Model -> Sub Msg
subscriptions model =
    Sub.none

getView : Model -> List (Html Msg)
getView model =
    case model.route of
        Routing.NotFoundRoute ->
            [ notFoundView ]

        _ ->
            [ Html.map NavBarMessages (NavBar.view { model = model.navBarModel, user = model.user })
            , Html.map SideBarMessages (SideBar.view { model = model.sideBarModel, user = model.user })
            , Html.map PageWrapperMessages (PageWrapper.view model.pageWrapperModel model.route)
            ]


notFoundView : Html Msg
notFoundView =
    div [ class "error-box" ]
        [ div [ class "error-body text-center" ]
            [ h1 []
                [ text "404" ]
            , h3 [ class "text-uppercase" ]
                [ text "Page Not Found !" ]
            , p [ class "text-muted m-t-30 m-b-30" ]
                [ text "YOU SEEM TO BE TRYING TO FIND HIS WAY HOME" ]
            , a [ href "/#", class "btn btn-info btn-rounded waves-effect waves-light m-b-40" ]
                [ text "Back to home" ]
            ]
        , footer [ class "footer text-center" ]
            [ text "2017 © Elite Admin." ]
        ]


main : Program Never Model Msg
main =
    Navigation.program OnLocationChange
        { init = init
        , view = view
        , update = update
        , subscriptions = subscriptions
        }
