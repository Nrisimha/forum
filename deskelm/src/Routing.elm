module Routing exposing (..)

import Navigation exposing (Location)
import UrlParser exposing (..)

type alias TicketId = Int

type Route
    = DashboardRoute
    | TicketViewRoute
    | SingleTicketViewRoute TicketId
    | NotFoundRoute


matchers : Parser (Route -> a) a
matchers =
    oneOf
        [ map DashboardRoute top
        , map TicketViewRoute (s "ticket")
        , map SingleTicketViewRoute (s "ticket" </> int)
        ]


parseLocation : Location -> Route
parseLocation location =
    case parseHash matchers location of
        Just route ->
            route

        Nothing ->
            NotFoundRoute


getRouteByName : { dashboard : String, ticketView : String }
getRouteByName =
    { dashboard = "/#"
    , ticketView = "/#/ticket/"
    }


pageTitle: Route -> String
pageTitle route =
    case route of
        DashboardRoute ->
            "Dashboard Page"
        TicketViewRoute->
            "Tickets View"
        SingleTicketViewRoute id ->
               "Ticket View"
        _ ->
            "Untitled Page"

