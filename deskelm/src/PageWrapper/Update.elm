module PageWrapper.Update exposing (..)

import PageWrapper.Messages exposing (..)
import PageWrapper.Model exposing (..)
import PageWrapper.RightSideBar.Update as RightSideBar
import Pages.Dashboard.Update as Dashboard
import Pages.Tickets.Update as Tickets
import Pages.SingleTicket.Update as SingleTicket


type ParentMsg
    = NoEffect


update : Msg -> Model -> ( Model, Cmd Msg, ParentMsg )
update msg model =
    case msg of
        NoOp ->
            ( model, Cmd.none, NoEffect )

        RightSideBarMessages subMsg ->
            let
                ( rightSideBarModel, rightSideBarCmd ) =
                    RightSideBar.update subMsg model.rightSideBarModel
            in
            ( { model | rightSideBarModel = rightSideBarModel }, Cmd.map RightSideBarMessages rightSideBarCmd, NoEffect )

        TicketsViewMessage subMsg ->
            let
                ( ticketsViewModel, ticketsViewCmd ) =
                    Tickets.update subMsg model.ticketsViewModel
            in
            ( { model | ticketsViewModel = ticketsViewModel }, Cmd.map TicketsViewMessage ticketsViewCmd, NoEffect )

        TicketViewMessage subMsg ->
            let
                ( ticketViewModel, ticketViewCmd ) =
                    SingleTicket.update subMsg model.ticketViewModel
            in
            ( { model | ticketViewModel = ticketViewModel }, Cmd.map TicketViewMessage ticketViewCmd, NoEffect )

        DashboardMessage subMsg ->
            let
                ( dashboardModel, dashboardCmd ) =
                    Dashboard.update subMsg model.dashboardModel
            in
            ( { model | dashboardModel = dashboardModel }, Cmd.map DashboardMessage dashboardCmd, NoEffect )
