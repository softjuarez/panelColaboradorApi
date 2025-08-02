import React, {useState} from "react";
import {Handle, Position} from "reactflow";
import { UserRound, UsersRound, Boxes, ShieldUser } from 'lucide-react';


const OrgChartNode = ({ data, id }) => {

    const availableIcons = [
        { component: UserRound, name: 'user' },
        { component: UsersRound, name: 'team' },
        { component: Boxes, name: 'department' },
        { component: ShieldUser, name: 'manager' }
    ];

    const selectedIcon = availableIcons.find(icon => icon.name === data.icon) || availableIcons[0];
    const IconComponent = selectedIcon.component;

  return (
    <div class="w-72 bg-white rounded-xl shadow-xs overflow-hidden border border-slate-250 hover:shadow-sm transition-all duration-200">
        <Handle type="target" position={Position.Top} id="a" className="!w-4 !h-4 !bg-teal-500 !border-teal-100 !border-2 !-mt-1.5"/>

        <div class="py-2.5 px-4 flex justify-between items-center" style={{ backgroundColor: data.color }}>
            <div class="w-7 h-7 bg-white rounded-full flex items-center justify-center">


                <IconComponent class="text-gray-700 w-4" />
            </div>

            <button
                onClick={(e) => {
                    e.stopPropagation();
                    const event = new CustomEvent("editNode", { detail: id });
                    window.dispatchEvent(event);
                }}
                className="w-7 h-7 bg-white rounded-full flex items-center justify-center hover:bg-gray-100"
            >
                <svg xmlns="http://www.w3.org/2000/svg" className="text-gray-700 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </button>
        </div>


        <div class="px-5 py-2 pt-4">
            <p class="text-gray-900 font-medium text-[1.05rem] leading-tight mb-1">{data.title}</p>

            <p class="text-gray-500 text-xs font-light uppercase tracking-wider mb-1">{data.subtitle}</p>

            <div class="flex items-center justify-between border-t border-slate-150 py-2">
                <div>

                </div>

                <div class="flex space-x-2.5">
                    <button
                        onClick={(e) => {
                            e.stopPropagation();
                            const event = new CustomEvent("editResponsabilitiesNode", { detail: id });
                            window.dispatchEvent(event);
                        }}
                         class="w-7 h-7 flex items-center justify-center rounded-md transition-colors duration-200 text-white"
                         style={{ backgroundColor: data.color }}>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white w-4"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/></svg>
                    </button>

                    <button
                        onClick={(e) => {
                            e.stopPropagation();
                            const event = new CustomEvent("editGroupMembersNode", { detail: id });
                            window.dispatchEvent(event);
                        }}
                    class="w-7 h-7 flex items-center justify-center rounded-md text-white"
                    style={{ backgroundColor: data.color }}>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white w-4"><path d="M18 21a8 8 0 0 0-16 0"/><circle cx="10" cy="8" r="5"/><path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <Handle type="source" position={Position.Bottom} id="b" className="!w-4 !h-4 !bg-teal-500 !border-teal-100 !border-2 !-mb-1.5" />
    </div>


  );
};

export default OrgChartNode;
