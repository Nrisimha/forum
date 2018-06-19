module RouteCommands exposing (..)

import Messages exposing (..)
import Pages.SingleTicket.Commands
import Pages.Tickets.Commands
import Routing


getOnInitCommand : Routing.Route -> Cmd Msg
getOnInitCommand route =
    case route of
        Routing.TicketViewRoute ->
            Pages.Tickets.Commands.getTickets
                |> Cmd.map OnFetchTickets

        Routing.SingleTicketViewRoute id ->
            Pages.SingleTicket.Commands.getTicket id
                |> Cmd.map OnFetchTicket

        _ ->
            Cmd.none
