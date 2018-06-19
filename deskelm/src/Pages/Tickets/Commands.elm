module Pages.Tickets.Commands exposing (..)

import Http
import Json.Decode as Decode
import Json.Decode.Pipeline exposing (decode, optional, required)
import Pages.Tickets.Model exposing (Ticket)
import RemoteData


getTickets : Cmd (RemoteData.WebData (List Ticket))
getTickets =
    Http.get fetchUrl ticketsDecoder
        |> RemoteData.sendRequest
        --|> Cmd.map OnFetchTickets


fetchUrl : String
fetchUrl =
    "/desk/ticket/ticketlist"


ticketsDecoder : Decode.Decoder (List Ticket)
ticketsDecoder =
    Decode.list ticketDecoder


ticketDecoder : Decode.Decoder Ticket
ticketDecoder =
    decode Ticket
        |> required "id" Decode.int
        |> required "user" Decode.string
        |> required "subject" Decode.string
        |> required "overwrite_subject" Decode.string
        |> required "tags" (Decode.list Decode.string)
        |> required "date" Decode.int
        |> required "status" Decode.string
        |> required "last_date" Decode.int
        |> required "user_messages" Decode.int
        |> required "agent_messages" Decode.int
        |> required "last_message_from" Decode.string
        |> required "handler_agent" Decode.string