module Pages.SingleTicket.Commands exposing (..)

import Http
import Json.Decode as Decode
import Json.Decode.Pipeline exposing (decode, optional, required)
import Pages.SingleTicket.Model exposing (CustomField, Ticket, Message)
import RemoteData


getTicket : Int -> Cmd (RemoteData.WebData Ticket)
getTicket id =
    Http.get (fetchUrl id) ticketDecoder
        |> RemoteData.sendRequest
        --|> Cmd.map OnFetchTickets


fetchUrl : Int -> String
fetchUrl id =
    "/desk/ticket/sampleticket/" ++ (toString id)


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
        |> required "custom_fields" (Decode.list customFieldsDecoder)
        |> required "messages" (Decode.list messageDecoder)
        |> required "team_discuss" (Decode.list messageDecoder)


customFieldsDecoder : Decode.Decoder CustomField
customFieldsDecoder =
    decode CustomField
        |> required "key" Decode.string
        |> required "value" Decode.string
        |> optional "areaType" Decode.string ""


messageDecoder : Decode.Decoder Message
messageDecoder =
    decode Message
        |> required "id" Decode.int
        |> required "user" Decode.string
        |> required "date" Decode.int
        |> required "message" Decode.string
