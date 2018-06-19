module Update exposing (..)

import Lens exposing (modelTicketLens, modelTicketsLens)
import Messages exposing (..)
import Models exposing (Model)
import Navbar.Update
import PageWrapper.Update
import Routing exposing (parseLocation)
import Sidebar.Update
import RouteCommands exposing(getOnInitCommand)

update : Msg -> Model -> ( Model, Cmd Msg )
update message model =
    case message of
        NavBarMessages subMsg ->
            let
                ( navBarModel, navBarCmd, childMessage ) =
                    Navbar.Update.update subMsg model.navBarModel
            in
            ( { model | navBarModel = navBarModel }, Cmd.map NavBarMessages navBarCmd )

        SideBarMessages subMsg ->
            let
                ( sideBarModel, sideBarCmd, childMessage ) =
                    Sidebar.Update.update subMsg model.sideBarModel
            in
            ( { model | sideBarModel = sideBarModel }, Cmd.map SideBarMessages sideBarCmd )

        PageWrapperMessages subMsg ->
            let
                ( pageWrapperModel, pageWrapperCmd, childMessage ) =
                    PageWrapper.Update.update subMsg model.pageWrapperModel
            in
            ( { model | pageWrapperModel = pageWrapperModel }, Cmd.map PageWrapperMessages pageWrapperCmd )

        OnLocationChange location ->
            let
                newRoute =
                    parseLocation location
            in
            ( { model | route = newRoute }, getOnInitCommand newRoute )

        OnFetchUser response ->
            ( { model | user = response }, Cmd.none )

        OnFetchTicket response ->
            ( modelTicketLens.set response model, Cmd.none )

        OnFetchTickets response ->
            ( modelTicketsLens.set response model, Cmd.none )
