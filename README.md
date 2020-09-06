# es-domainevents
Domain Events and Event Sourcing implementation in php

Introduction:
The world is in chaos, people can have their houses anytime! The robbers are ruthless, they can rob houses from people and steal their money, increasing their fame, the robbers belong to the underworld. However one can hope, if we have the divine alarms in our houses they can warn people and the police station and send cops to catch these nasty robbers, and after that we can only pray that they succeed.

Domain:
- House 
  - House
  - Person
  - Alarm
  
- Police
  - PoliceStation
  - Cop
  
- Robber | Underworld
  - Robber
  - BlackMarket
  - RobberAgency
  
These are the domain artifacts, not all of them are implemented yet.
The idea is that each House, Police, Robber are bounded contexts, and each is in its application.
The project is implemented in memory but design as if they were 3 distinct applications

Use cases:
  
  House:
    - Create a house
    - Notify police station (not implemented)
    
  Police: (not implemented)
    - Hunt down the robber
    
  Robber:
    - Create robber
    - Assault/rob a house
    

Interaction:
  Assault/rob a house
    1. Robber -> Assaults a house -> dispatch(AssaultedHouseEvent( robberInformation, houseId )) (global event)
    2. House -> listens(AssaultedHouseEvent(payload) -> process event -> modify house state
       ->dispatch(AssaultHouseSuccessEvent) (not implemented)
    3. Robber -> listens(AssaultedHouseSuccessEvent) -> process event -> modify robber state (not implemented)
  

Questions
- Event versioning
- Streams per aggregate (?)
- Mark domain events that dont change state (?) Should i apply events to the aggregate that dont change state (?)
- Event scope, difference between global events from local events
- Event de-decoupling is missing
- Project structure requires some work
