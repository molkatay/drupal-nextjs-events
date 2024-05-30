import React from 'react'
import Card from "./common/Card";

const Articles = ({ nodes }) => {

    return (
        <section
            className="flex-col flexCenter overflow-hidden bg-feature-bg bg-center bg-no-repeat py-24">

            <div
                className="max-container padding-container relative w-full flex justify-end">


                <div className="z-20 flex w-full flex-col">
                    <div className='flexCenter relative'>
                        <h2 className="bold-40 lg:bold-64">Latest Articles</h2>
                    </div>

                        <ul className="grid grid-cols-1 xl:grid-cols-3 gap-y-10 gap-x-6 items-start p-8">
                            {nodes?.length ? (
                                nodes.map((node) => (

                                    <Card key={node.id} node={node}/>
                                ))
                            ) : (
                                <p className="py-4">No nodes found</p>
                            )}

                        </ul>


                </div>
            </div>


        </section>


    )
}


export default Articles
