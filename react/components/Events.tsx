import React from 'react'
import Card from "./common/Card";

const Events = ({ events }) => {

    return (
        <section
            className="flex-col flexCenter overflow-hidden bg-feature-bg bg-center bg-no-repeat py-24">

            <div
                className="max-container padding-container relative w-full flex justify-end">


                <div className="z-20 flex w-full flex-col">
                    <div className='flexCenter relative'>
                        <h2 className="bold-40 lg:bold-64">Latest Events</h2>
                    </div>

                        <ul className="grid grid-cols-1 xl:grid-cols-3 gap-y-10 gap-x-6 items-start p-8">
                            {events?.length ? (
                                events.map((event) => (

                                    <Card key={event.id} node={event}/>
                                ))
                            ) : (
                                <p className="py-4">No events found</p>
                            )}

                        </ul>


                </div>
            </div>


        </section>


    )
}


export default Events
