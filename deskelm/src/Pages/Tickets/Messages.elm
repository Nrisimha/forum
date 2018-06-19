module Pages.Tickets.Messages exposing(..)

import RemoteData exposing (WebData)
import Pages.Tickets.Model exposing(Ticket)


type Msg
    = NoOp
    | OnFetchTickets (WebData (List Ticket))