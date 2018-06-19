module Pages.SingleTicket.Messages exposing(..)

import RemoteData exposing(WebData)
import Pages.SingleTicket.Model exposing(..)
type Msg
    = NoOp
    | OnFetchTicket (WebData Ticket)
    | OnMessagesTab MessagesTab