module Pages.Tickets.Model exposing (..)

import RemoteData exposing (WebData)

type alias Model =
    { tickets : WebData (List Ticket) }


type alias Ticket =
    { id : Int
    , user : String
    , subject : String
    , overwrite_subject : String
    , tags : List String
    , date : Int
    , status : String
    , last_date : Int
    , user_messages : Int
    , agent_messages : Int
    , last_message_from : String
    , handler_agent : String
    }


model : Model
model =
    { tickets = RemoteData.Loading }
