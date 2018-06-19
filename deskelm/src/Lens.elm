module Lens exposing (..)

import Models
import Monocle.Lens exposing (..)
import PageWrapper.Model
import Pages.SingleTicket.Model
import Pages.Tickets.Model
import RemoteData exposing (WebData)


ticketsViewTicketsLens : Lens Pages.Tickets.Model.Model (WebData (List Pages.Tickets.Model.Ticket))
ticketsViewTicketsLens =
    Lens .tickets (\wd t -> { t | tickets = wd })


ticketViewTicketsLens : Lens Pages.SingleTicket.Model.Model (WebData Pages.SingleTicket.Model.Ticket)
ticketViewTicketsLens =
    Lens .ticket (\wd t -> { t | ticket = wd })


pageWrapperTicketsViewLens : Lens PageWrapper.Model.Model Pages.Tickets.Model.Model
pageWrapperTicketsViewLens =
    Lens .ticketsViewModel (\twm pw -> { pw | ticketsViewModel = twm })


pageWrapperTicketViewLens : Lens PageWrapper.Model.Model Pages.SingleTicket.Model.Model
pageWrapperTicketViewLens =
    Lens .ticketViewModel (\twm pw -> { pw | ticketViewModel = twm })


ticketsPageWrapperLens : Lens PageWrapper.Model.Model (WebData (List Pages.Tickets.Model.Ticket))
ticketsPageWrapperLens =
    compose pageWrapperTicketsViewLens ticketsViewTicketsLens


ticketPageWrapperLens : Lens PageWrapper.Model.Model (WebData Pages.SingleTicket.Model.Ticket)
ticketPageWrapperLens =
    compose pageWrapperTicketViewLens ticketViewTicketsLens


modelPageWrapperLens : Lens Models.Model PageWrapper.Model.Model
modelPageWrapperLens =
    Lens .pageWrapperModel (\pwm m -> { m | pageWrapperModel = pwm })


---- Final Lens


modelTicketsLens : Lens Models.Model (WebData (List Pages.Tickets.Model.Ticket))
modelTicketsLens =
    compose modelPageWrapperLens ticketsPageWrapperLens


modelTicketLens : Lens Models.Model (WebData Pages.SingleTicket.Model.Ticket)
modelTicketLens =
    compose modelPageWrapperLens ticketPageWrapperLens

