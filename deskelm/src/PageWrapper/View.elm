module PageWrapper.View exposing (..)

import Html exposing (..)
import Html.Attributes exposing (..)
import PageWrapper.Messages exposing (..)
import PageWrapper.Model exposing (..)
import PageWrapper.RightSideBar.View as RightSideBar
import Pages.Dashboard.View as Dashboard
import Pages.Tickets.View as Tickets
import Pages.SingleTicket.View as SingleTicketView

import Routing

view : Model -> Routing.Route -> Html Msg
view model route =
    div [ id "page-wrapper" ]
        [ div [ class "container-fluid" ]
            [ div [ class "row bg-title" ]
                [ div [ class "col-lg-3 col-md-4 col-sm-4 col-xs-12" ]
                    [ h4 [ class "page-title" ]
                        [ text (Routing.pageTitle route) ]
                    ]
                , div [ class "col-lg-9 col-sm-8 col-md-8 col-xs-12" ]
                    [ a [ href "#", target "_blank", class "btn btn-danger pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light" ]
                        [ text "Button" ]
                    , ol [ class "breadcrumb" ]
                        [ li []
                            [ a [ href (.dashboard Routing.getRouteByName) ]
                                [ text "Dashboard" ]
                            ]
                        , li [ class "active" ]
                            [ text (Routing.pageTitle route) ]
                        ]
                    ]
                ]
            , div [ class "row" ] [ page model route ]
            , Html.map RightSideBarMessages (RightSideBar.view model.rightSideBarModel)
            ]
        , footer [ class "footer text-center" ]
            [ text "2017", text " ©", text " Ticket Sistem" ]
        ]


page : Model -> Routing.Route -> Html Msg
page model route=
    case route of
        Routing.DashboardRoute ->
            Html.map DashboardMessage (Dashboard.view model.dashboardModel)
        Routing.TicketViewRoute->
            Html.map TicketsViewMessage (Tickets.view model.ticketsViewModel)

        Routing.SingleTicketViewRoute id->
            Html.map TicketViewMessage (SingleTicketView.view model.ticketViewModel)

        _ ->
           Html.map DashboardMessage (Dashboard.view model.dashboardModel)