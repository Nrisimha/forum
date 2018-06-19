module Pages.SingleTicket.Model exposing (..)

import RemoteData exposing (WebData)


type alias Model =
    { ticket : WebData Ticket, messagesTab: MessagesTab }


type MessagesTab
    = Messages
    | TeamDiscussion


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
    , custom_fields : List CustomField
    , messages : List Message
    , team_discuss : List Message
    }


type alias CustomField =
    { key : String
    , values : String
    , areaType : String
    }


type alias Message =
    { id : Int
    , user : String
    , date : Int
    , message : String
    }


model : Model
model =
    { ticket = RemoteData.Loading, messagesTab = Messages }
